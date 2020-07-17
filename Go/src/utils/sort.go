package utils
// 这是一个接口
type Sort interface {
	BubbleSort() []int
}
// 这是一个实体类
type ArrayObj struct {
	Array []int
}

// 实体实现了接口的方法 继承
func (array ArrayObj) BubbleSort() []int {
	if array == nil {
		fmt.Println("array is empty")
		return [];
	} 
}
