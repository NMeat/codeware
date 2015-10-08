import java.io.*;
import java.util.*;
public class test 
{
    public static void main(String[] args) 
    {
        System.out.println("Enter a, b, c: ");
        Scanner input = new Scanner(System.in);
        double a = input.nextDouble();
        double b = input.nextDouble();
        double c = input.nextDouble();
        double delta = b * b - 4 * a * c;
        double t = Math.pow(delta, 0.5);
        if(delta > 0) {
            double x1 = (-b + t) / 2;
            double x2 = (-b - t) / 2;
            System.out.println("The roots are " + x1 + " and " + x2);
        } else if (delta == 0) {
            System.out.println("The root is " + -b / (2 * a));
        } else {
            System.out.println("The equation has no real roots");
        }
    }
}
