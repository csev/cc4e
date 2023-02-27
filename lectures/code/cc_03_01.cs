using System;

public class Point
{
   public double x,y;

   public Point(double cx, double cy) {
       x = cx;
       y = cy;
   }

   public void dump() {
       Console.WriteLine("Point object x={0} y={1}", x, y);
   }

   public double origin() {
        return Math.Sqrt(x*x+y*y);
   }
}

class TestPoint{
    public static void Main(string[] args)
     {
         Point pt = new Point(4.0, 5.0);
         pt.dump();
         Console.WriteLine("Origin {0}", pt.origin());
     }
}

// https://www.programiz.com/csharp-programming/online-compiler/

