public class cc_03_01 {

    public static void main(String[] args)
    {   
		System.out.println("In Main");
		Point pt = new Point(4.0, 5.0);
		pt.dump();
		System.out.println("Origin "+pt.origin());
    }
}

// javac Point.java ; javac cc_03_01.java ; java cc_03_01
