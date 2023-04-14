#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <ctype.h>

#include "map_tree.c"

/**
 * The main program to test and exercise the TreeMap classes.
 */
int main(void)
{
    struct TreeMap * map = TreeMap_new();
    struct TreeMapEntry *cur;
    struct TreeMapIter *iter;
    char name[100];  // Yes, this is dangerous
    char word[100];  // Yes, this is dangerous
    int i,j;
    int count, maxvalue;
    char *maxkey;

    printf("Enter file name: ");
    scanf("%s", name);

    FILE *fp = fopen(name, "r");
    
    // Loop over each word in the file
    while (fscanf(fp, "%s", word) != EOF) {
        for (i=0, j=0; word[i] != '\0'; i++) {
            if ( ! isalpha(word[i]) ) continue;
            word[j++] = tolower(word[i]);
        }
        word[j] = '\0';
        count = map->get(map, word, 0);
        map->put(map, word, count+1);
    }
    fclose(fp);

    map->dump(map);

    printf("\nFind max...\n");
    maxkey = NULL;
    maxvalue = -1;
    iter = map->iter(map);
    while(1) {
        cur = iter->next(iter);
        if ( cur == NULL ) break;
        if ( maxkey == NULL || cur->value > maxvalue ) {
            maxkey = cur->key;
            maxvalue = cur->value;
        }
    }
    iter->del(iter);
    printf("\n%s %d\n", maxkey, maxvalue);

    map->del(map);
}

// rm -f a.out ; gcc map_tree_words.c; a.out ; rm -f a.out

