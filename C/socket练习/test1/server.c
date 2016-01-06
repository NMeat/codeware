#include <stdio.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <arpa/inet.h>

int main(int argc, char *argv[])
{
    //套接字描述符    其实就是一个整数，我们最熟悉的句柄是0、1、2三个，0是标准输入，1是标准输出，2是标准错误输出
    //0、1、2是整数表示的 对应的FILE *结构的表示就是stdin、stdout、stderr
    int server_sockfd;      //服务器端套接字
    int client_sockfd;      //客户端套接字
    int len;
    struct sockaddr_in my_addr;     //服务器网络地址结构体
    struct sockaddr_in remote_addr; //客户端网络地址结构体
    int sin_size;
    char buf[BUFSIZ];                     //数据传送的缓冲区 使用stdio.h头文件中定义的BUFSIZ
    memset(&my_addr, 0, sizeof(my_addr)); //数据初始化--清零
    my_addr.sin_family = AF_INET;         //设置为IP通信(TCP/IP – IPv4) AF:Address Family PF:Protocol Family
    my_addr.sin_addr.s_addr = INADDR_ANY; //服务器IP地址为0:0:0:0 意为所有地址、任意地址--允许连接到所有本地地址上
    my_addr.sin_port   = htons(8000);     //服务器端口号
    
    /**
     *创建服务器端套接字--IPv4协议，面向连接通信，TCP协议---------------------------->创建socket
     *
     * int socket(int protofamily, int type, int protocol);  //返回sockfd
     * protofamily  即协议域，又称为协议族（family）AF_INET(IPV4) AF_INET6(IPV6)
     * type         指定socket类型 SOCK_STREAM、SOCK_DGRAM、SOCK_RAW、SOCK_PACKET、SOCK_SEQPACKET
     * protocol     就是指定协议 IPPROTO_TCP、IPPTOTO_UDP、IPPROTO_SCTP、IPPROTO_TIPC
     *
     * socket()返回'套接字描述符'
     */
    if((server_sockfd = socket(PF_INET, SOCK_STREAM, 0)) < 0){  
        perror("socket");   //用来将上一个函数发生错误的原因输出到标准设备(stderr)
        return 1;
    }
 
    /**
     *监听连接请求--监听队列长度为5-------------------------------------------------->监听端口号
     *  int bind(int sockfd, const struct sockaddr *addr, socklen_t addrlen)
     *  sockfd  ：即套接字描述符，它是通过socket()函数创建了，唯一标识一个socket
     *  addr    ：一个const struct sockaddr *指针，指向要绑定给sockfd的协议地址
     *  addrlen ：对应的是地址的长度
     */
    if (bind(server_sockfd, (struct sockaddr *) &my_addr, sizeof(struct sockaddr)) < 0){
        perror("bind");
        return 1;
    }
    
    /**
     *监听连接请求--监听队列长度为5-------------------------------------------------->监听端口号
     *  int listen(int sockfd, int backlog);
     *  sockfd  ：即套接字描述符
     *  backlog : 相应socket可以排队的最大连接个数
     *  注:socket()函数创建的socket默认是一个主动类型的，listen()函数将socket变为被动类型的，等待客户的连接请求
     */
    listen(server_sockfd, 5);
    
    sin_size = sizeof(struct sockaddr_in);
    
    /**
     *  等待客户端连接请求到达 阻塞 等待客户端的请求----------------------------------->阻塞直到有客户端连接
     *  TCP服务器端依次调用socket()、bind()、listen()之后，就会监听指定的socket地址
     *  TCP客户端依次调用socket()、connect()之后就向TCP服务器发送了一个连接请求
     *  TCP服务器监听到这个请求之后，就会调用accept()函数取接收请求，这样连接就建立好了
     *  之后就可以开始网络I/O操作了，即类同于普通文件的读写I/O操作
     *  int accept(int sockfd, struct sockaddr *addr, socklen_t *addrlen); //返回连接connect_fd
     *  sockfd  ：即套接字描述符
     *  addr    : 这是一个结果参数 它用来接受一个返回值 这返回值指定客户端的地址
     *  addrlen : 用来接受上述addr的结构的大小的，它指明addr结构所占有的字节个数
     *
     *  如果accept成功返回，则服务器与客户已经正确建立连接了 此时服务器通过accept返回的套接字来完成与客户的通信
     */
    if((client_sockfd = accept(server_sockfd, (struct sockaddr *) &remote_addr, &sin_size)) < 0){
        perror("accept");
        return 1;
    }

    printf("accept client %s\n", inet_ntoa(remote_addr.sin_addr));

    /**
     *  万事具备只欠东风 至此服务器与客户已经建立好连接了
     *  可以调用网络I/O进行读写操作了 即实现了网咯中不同进程之间的通信
     *  read()/write() recv()/send() readv()/writev() recvmsg()/sendmsg() recvfrom()/sendto()
     *  read()函数  read返回实际所读的字节数，如果返回的值是0表示已经读到文件的结束了 小于0表示出现了错误
     *  write()函数 write函数将buf中的N bytes字节内容写入文件描述符fd 成功时返回写的字节数 失败时返回-1，
     *
     *  不论是客户还是服务器应用程序都用send函数来向TCP连接的另一端发送数据
     *  int send( SOCKET s, const char FAR *buf, int len, int flags )
     *  第一个参数   指定发送端套接字描述符；
     *  第二个参数   指明一个存放应用程序要发送数据的缓冲区；
     *  第三个参数   指明实际要发送的数据的字节数；
     *  第四个参数   一般置0 
     */
    len = send(client_sockfd, "Welcome to my server\n", 21, 0);         //发送欢迎信息 经套接字传送消息
    
    //接收客户端的数据并将其发送给客户端--recv返回接收到的字节数，send返回发送的字节数
    while((len = recv(client_sockfd, buf, BUFSIZ, 0)) > 0){
        buf[len] = '\0';
        printf("%s\n", buf);
        if(send(client_sockfd, buf, len, 0) < 0){
            perror("write");
            return 1;
        }
    }

    close(client_sockfd);
    close(server_sockfd);
    return 0;
}