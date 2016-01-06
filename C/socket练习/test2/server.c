#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <arpa/inet.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>

char* recv_msg(int socket_fd);

int main(int argc, char *argv[]) {
    int server_fd, client_fd;           //套接字描述符
    struct sockaddr_in server_addr;     //服务器网络地址结构体
    struct sockaddr_in client_addr;

    //创建套接字
    if (-1 == (server_fd = socket(AF_INET, SOCK_STREAM, 0))) {
        perror("Error: Can not create socket.");
        exit(EXIT_FAILURE);
    }
    printf("# Create socket: %d\n", server_fd);             //打印套接字描述符

    memset(&server_addr, 0, sizeof(struct sockaddr_in));    //初始化服务器网络地址结构体
    server_addr.sin_family = AF_INET;
    server_addr.sin_port = htons(1100);                     //监听1100端口
    server_addr.sin_addr.s_addr = INADDR_ANY;

    //绑定套接字
    if (-1 == bind(server_fd, (const struct sockaddr *)&server_addr, sizeof(struct sockaddr_in))) {
        perror("Error: Bind failed.");
        close(server_fd);
        exit(EXIT_FAILURE);
    }
    printf("# Bind socket: %d\n", server_fd);               //打印套接字描述符

    //监听套接字
    if (-1 == listen(server_fd, 10)) {
        perror("Error: Listen failed.");
        close(server_fd);
        exit(EXIT_FAILURE);
    }
    printf("# Listen socket: %d\n", server_fd);             //打印套接字描述符

    while(1) {
        int client_addr_len = sizeof(struct sockaddr_in);   //客户端网络地址长度
        //阻塞监听客户端连接
        client_fd = accept(server_fd, (struct sockaddr *) &client_addr, &client_addr_len);

        if (0 > client_fd) {
            perror("Error: Accept failed.");
            close(server_fd);
            exit(EXIT_FAILURE);
        }
        printf("accept client: %d\n", client_fd);

        char* msg = (char*) malloc(10240);  //申请一块内存
        if (-1 == recv(client_fd, msg, 10240, 0)) {
            perror("Error: Receive message error.");
        } else {
            printf("%s\n", msg);            //打印接收的数据
        }
        free(msg);  //释放内存

        shutdown(client_fd, SHUT_RDWR);
        close(client_fd);
    }

    close(server_fd);
    printf("# Close server socket.\n");
    return 0;
}