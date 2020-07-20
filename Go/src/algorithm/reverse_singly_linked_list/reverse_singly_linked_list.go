package main

import (
	"fmt"
)

// Node 一个节点结构体
type Node struct {
	value    int
	nextNode *Node
}

// ReverseNode 反转单链表
func ReverseNode(head *Node) *Node {
	var preNode *Node
	preNode = nil

	nextNode := new(Node)
	nextNode = nil
	// i := 1
	for head != nil {
		// 保存当前节点的下一个节点
		nextNode = head.nextNode
		// 将当前头节点的下一个节点指向 “上一个节点”（当前头节点2 指向了 (“上一个节点”)节点1），这一步才是实现反转
		head.nextNode = preNode
		// 将当前头节点设置 “上一个节点”（将节点2 设为“上一个节点”）
		preNode = head
		// 将保存的下一个节点设置 “头节点”（将节点3 设为“头节点”）
		head = nextNode
	}

	return preNode
}

func printNode(head *Node) {
	for head != nil {
		fmt.Print(head.value, "\t")
		fmt.Println(head)
		head = head.nextNode
	}
	fmt.Println()
}

func main() {
	println("hello 反转单链表")
	node1 := new(Node)
	node1.value = 1
	node2 := new(Node)
	node2.value = 2
	node3 := new(Node)
	node3.value = 3
	node4 := new(Node)
	node4.value = 4
	node5 := new(Node)
	node5.value = 5

	node1.nextNode = node2
	node2.nextNode = node3
	node3.nextNode = node4
	node4.nextNode = node5
	printNode(node1)

	head := ReverseNode(node1)
	printNode(head)
}
