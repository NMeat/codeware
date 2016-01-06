#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <arpa/inet.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
 
int main(void) {
    char server_ip[15]; //IP地址字符数据
    int server_port;    //服务器端口
    struct sockaddr_in server_addr; //服务器网络地址
    int client_fd, res; //用户端套接字描述符

    printf("Please Enter the Server IP: ");
    fflush(stdout);     //刷新标准输出缓冲区，把输出缓冲区里的东西打印到标准输出设备上
    scanf("%s", server_ip); //输入服务器的IP地址
    printf("Please Enter the Server port: ");   //服务器端监听端口号
    fflush(stdout);
    scanf("%d", &server_port);

    memset(&server_addr, 0, sizeof(struct sockaddr_in));          
    server_addr.sin_family = AF_INET;
    server_addr.sin_port = htons(server_port);
    res = inet_pton(AF_INET, server_ip, &server_addr.sin_addr);

    if (0 > res) {
        perror("error: first parameter is not a valid address family");
        close(client_fd);
        exit(EXIT_FAILURE);
    } else if (0 == res) {
        perror("char string (second parameter does not contain valid ipaddress");
        close(client_fd);
        exit(EXIT_FAILURE);
    }

    char str[100];
    while (1) {
        if (-1 == (client_fd = socket(PF_INET, SOCK_STREAM, 0))) { //创建客户端socket描述符
            perror("cannot create socket");
            exit(EXIT_FAILURE);
        }
        printf("Create socket: %d\n", client_fd);

        if (-1 == connect(client_fd, (const struct sockaddr *) &server_addr, sizeof(struct sockaddr_in))) {
            perror("connect failed");
            close(client_fd);
            exit(EXIT_FAILURE);
        }

        printf("I want to say : ");
        scanf("%s", str);

        if (!strcmp(str, "exit")) {
            send(client_fd, str, sizeof(str), 0);
            break;
        }

        if (0 > send(client_fd, str, sizeof(str), 0)) { //发送消息
            printf("[Send error]\n");
        } else {
            printf("[Send success]\n");
        }
        memset(str, 0, sizeof(str));
        shutdown(client_fd, SHUT_RDWR);
        close(client_fd);
        printf("----------------------Closed socket-----------------------------\n\n");
    }

    return 0;
}