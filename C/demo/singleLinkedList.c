#include <stdio.h>
#include <stdlib.h>

// #define EOF 111

typedef int ElemType;



//定义节点类型
typedef struct Node
{
	ElemType data;			//单链表的数据域
	struct Node *next;		//单链表中的指针域
}Node, *LinkedList;


//单链表的初始化  指针函数
LinkedList LinkedListInt()
{
	Node *L;
	L = (Node *)malloc(sizeof(Node)); //申请结点空间
	if (NULL == L)
	{
		printf("申请结点空间换败\n");
	}
	L->next = NULL;	//将next设置为NULL,初始长度为0的单链表
	return L;
}

//单链表的建立1，头插法建立单链表 
LinkedList LinkedListCreateH()
{
	Node *L;
	L = (Node *)malloc(sizeof(Node));  //申请头结节空间
	L->next = NULL;

	ElemType x;

	while(scanf("%d", &x) != EOF){
		Node *p;
		p = (Node *)malloc(sizeof(Node)); //申请新的节点
		p->data = x;		//节点数据域赋值
		p->next = L->next;	//将结点插入到表头
		L->next = p;
	}
	return L;
}

//单链表的建立2，尾插法建立单链表
LinkedList LinkedListCreateT()
{
	Node *L;
	L = (Node *)malloc(sizeof(Node));//申请头结点空间
	L->next = NULL;

	Node *r;
	r = L;
	ElemType x;
	while(scanf("%d", &x) != EOF){
		Node *p;
		p = (Node *)malloc(sizeof(Node));//申请新的节点
		p->data = x;
		r->next = p;
		r = p;
	}
	r->next = NULL;
	return L;
}


//单链表的插入，在链表的第i个位置插入x的元素
LinkedList LinkedListInsert(LinkedList L, int i, ElemType x)
{
	Node *pre; //前驱节点
	pre = L;

	int tempi = 0;
	for (tempi = 1; tempi < i; ++tempi)
	{
		pre = pre->next;
	}

	Node *p;//插入新的节点
	p = (Node *)malloc(sizeof(Node));
	p->data = x;
	p->next = pre->next;
	pre->next = p;

	return L;
}

//单链表的删除，在链表中删除值为x的元素
LinkedList LinkedListDelete(LinkedList L, ElemType x)
{
	Node *pre, *p;	//pre为前驱结点，p为查找的结点。
	p = L->next;
	while(p->data != x){
		pre = p;
		p = p->next;
	}
	pre->next = p->next;
	free(p);
	return L;
}
int main(int argc, char const *argv[])
{
	LinkedList list, start;
	printf("请输入单链表的数据\n");

	list = LinkedListCreateT();
	for(start = list->next; start != NULL; start = start->next){
		printf("%d\n", start->data);
	}	

	int i;
	ElemType x;

	printf("请输入插入数据的位置：");
	scanf("%d", &i);
	
	printf("请输入插入数据的值：");    
    scanf("%d",&x);

    LinkedListInsert(list,i,x);
    for(start = list->next; start != NULL; start = start->next){
    	printf("%d ",start->data);
    }

    printf("\n");
    printf("请输入要删除的值\n");
    scanf("%d", &x);

    LinkedListDelete(list, x);
    for (start = list->next; start != NULL; start = start->next)
    {
    	printf("%d\n", start->data);
    }

	return 0;
}














