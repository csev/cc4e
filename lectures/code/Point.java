import java.lang.Math;

public class Point {
   double x,y;

   Point(double x, double y) {
	   this.x = x;
	   this.y = y;
   }

   void dump() {
	   System.out.printf("%s x=%f y=%f\n", this, this.x, this.y);
   }

   double origin() {
        return Math.sqrt(this.x*this.x+this.y*this.y);
	}
}
