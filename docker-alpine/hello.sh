cd /tmp
cat > student.c << EOF

#include <stdio.h>

main() {
    printf("Hello world\n");
}

EOF

cat > romeo.txt << EOF
But soft what light through yonder window breaks
It is the east and Juliet is the sun
Arise fair sun and kill the envious moon
Who is already sick and pale with grief
EOF

/usr/bin/gcc -ansi student.c

[ -f a.out ] && ./a.out

ls -l 

