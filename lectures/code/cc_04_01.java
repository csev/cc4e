import java.util.Map;
import java.util.TreeMap;

public class cc_04_01 {

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

        System.out.printf("\nIterate forwards\n");
        for (Map.Entry<String,Integer> entry : map.entrySet()) {
                System.out.println("Key = " + entry.getKey() + ", Value = " + entry.getValue());
        }

        Integer max = null;
        String max_key = null;
        for (Map.Entry<String,Integer> entry : map.entrySet()) {
                if ( max == null || entry.getValue() > max ) {
                    max = entry.getValue();
                    max_key = entry.getKey();
                }
        }

        System.out.printf("The largest value is %s=%d\n", max_key, max);
    }
}

// javac cc_04_01.java ; java cc_04_01 ; rm *.class

