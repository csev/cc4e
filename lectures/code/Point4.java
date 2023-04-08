public class Point4 {
   private double x,y;

   Point4(double x, double y) {
	   this.x = x;
	   this.y = y;
   }

   public void dump() {
	   System.out.printf("%s x=%f y=%f\n", this, this.x, this.y);
   }
}
