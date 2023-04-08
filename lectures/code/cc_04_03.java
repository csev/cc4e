import java.util.Map;
import java.util.TreeMap;

public class cc_04_03 {

    public static void main(String[] args)
    {   
        Map<String, Integer> map = new TreeMap<String, Integer> ();

        System.out.printf("Testing Map class\n");
        map.put("z", 8);
        map.put("z", 1);
        map.put("y", 2);
        map.put("b", 3);
        map.put("a", 4);
        System.out.println(map);

        System.out.println("z="+map.getOrDefault("z", 42));
        System.out.println("x="+map.getOrDefault("x", 42));

        System.out.printf("\nIterate\n");
        for (Map.Entry<String,Integer> entry : map.entrySet()) {
                System.out.println("Key = " + entry.getKey() + ", Value = " + entry.getValue());
        }

    }
}

// javac cc_04_03.java ; java cc_04_03 ; rm *.class

