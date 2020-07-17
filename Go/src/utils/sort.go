package utils

type Sort interface {
	BubbleSort() []int
}

type ArrayObj struct {
	Array []int
}

func (array ArrayObj) BubbleSort() []int {
	if array == nil {
		fmt.Println("array is empty")
		return [];
	} 
}
