package main
import "fmt"

func main(){
    values := [] int{3,7,5,4,3,2,3,4,5,90}
    resultChan := make(chan int, 2)
    go sum(values[:len(values)/2], resultChan)
    go sum(values[len(values)/2:], resultChan)

    sum1, sum2 := <-resultChan, <-resultChan

    fmt.Println("Result:", sum1, sum2, sum1 + sum2)
}

func sum(values [] int, resultChan chan int){
    sum := 0;
    for _, value := range values{
        sum += value
    }

    resultChan <- sum
}
