#include <stdio.h>
#include <stdlib.h>

//定义一个结构体类型node,有两个成员属性
typedef struct node
{
	int data;
	struct node *next;
}linkNode, *link;

//创建链表
link create_link()
{
	int number;
	link head, p, r;
	head = (link) malloc(sizeof(linkNode)); //申请一块内存给头节点
	head->next = NULL; //头节点的下个节点指针为NULL
	number = scanf("%d", &number);
	r = head;

	while(number != -1){
		p = (link) malloc(sizeof(linkNode));
		p->data = number; //给成员赋值
		r->next = p;
		r = p;
		scanf("%d", &number);
	}
	r->next = NULL;
	return head;
}

//查找
link get_link(link head, int index)
{
	int j = -1;
	if(index < 0){
		return NULL;
	}

	link p = head;
	while(p->next && j < index){
		p = p->next;
		j++;
	}

	if(j == index){
		return p;
	}

	return NULL;
}

//定位元素
link locate_link(link head, int value)
{
	link p = head->next;

	while(p){
		if (p->data == value){
			return p;
		}
		p = p->next;
	}
	return NULL;
}
//插入元素
void insert_link(link head, int index, int value)
{
	link p, locate;

	if(index == 0){
		locate = head;
	}else{
		locate = get_link(head, (index - 1));
	}


	if(locate){
		p = (link)malloc(sizeof(linkNode));
		p->data = value;
		p->next = locate->next;
		locate->next = p;
	}else{
		printf("error\n");
	}
}

//删除节点
void delete_link(link head, int index)
{
	link p,locate;
	if(index == 0){
		locate = head;
	}else{
		locate = get_link(head, (index-1));
	}

	if (locate && locate->next){
		p = locate->next;
		locate->next = p->next;
		free(p);
		return;
	}

	printf("not found\n");
}

//打印链表
void print_link(link head)
{
	link tmp = head;
	while(tmp->next != NULL){
		printf("打印----%d\n", tmp->next->data);
		tmp = tmp->next;
	}
}


int main(int argc, char const *argv[])
{
	link head = create_link();

	print_link(head);

	link res = get_link(head, 7);
	if (res != NULL){
		printf("find res %d\n", res->data);
	}

	delete_link(head, 2);
	print_link(head);
	return 0;
}






