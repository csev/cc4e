#include <stdio.h>

int getBucket(char *str, int buckets)
{
    unsigned int hash = 123456;
    printf("\nHashing %s\n", str);
    if ( str == NULL ) return 0;
    for( ; *str ; str++) {
        hash = ( hash << 3 ) ^ *str;
        printf("%c 0x%08x %d\n", *str, hash, hash % buckets);
    }
    return hash % buckets;
}

int main() {
    int h;
    
    h = getBucket("Hi", 8);
    h = getBucket("Hello", 8);
    h = getBucket("World", 8);
}

// rm -f a.out ; gcc cc_05_01.c; a.out ; rm -f a.out

