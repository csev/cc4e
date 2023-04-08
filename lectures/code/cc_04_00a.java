public class cc_04_00a {

    public static void main(String[] args)
    {   
		Point pt = new Point(4.0, 5.0);
		pt.dump();
		System.out.printf("Origin %f\n",pt.origin());
    }
}

// javac Point4.java ; javac cc_04_00a.java ; java cc_04_00a ; rm *.class
