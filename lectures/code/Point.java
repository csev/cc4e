import java.lang.Math;

public class Point {
   double x,y;

   Point(double x, double y) {
	   this.x = x;
	   this.y = y;
   }

   void dump() {
	   System.out.println(this+" x="+this.x+" y="+this.y);
   }

   double origin() {
        return Math.sqrt(this.x*this.x+this.y*this.y);
	}
}
