#include <stdio.h>
#include <string.h>

struct books
{
	char title[50];
	char author[50];
	char subject[50];
	int bookId;
};


int main(int argc, char const *argv[])
{
	struct books book1;
	strcpy( book1.title, "C Programming");
	strcpy( book1.author, "Nuha Ali"); 
    strcpy( book1.subject, "C Programming Tutorial");
    book1.bookId = 6495407;

	/* 输出 Book1 信息 */
	printf( "book1 title : %s\n", book1.title);
	printf( "book1 author : %s\n", book1.author);
	printf( "book1 subject : %s\n", book1.subject);
	printf( "book1 bookId : %d\n", book1.bookId);
	return 0;
}