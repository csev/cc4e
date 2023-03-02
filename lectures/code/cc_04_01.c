
int main(void)
{
    struct mnode *cur;
    struct Map * map = Map_new();

    printf("Testing Map class\n");
    map->put(map, "z", 8);
    map->put(map, "z", 1);
    map->put(map, "y", 2);
    map->put(map, "b", 3);
    map->put(map, "a", 4);
    map->dump(map);

    printf("z=%d\n", map->get(map, "z", 42));
    printf("x=%d\n", map->get(map, "x", 42));

    printf("\nIterate forwards\n");
    for(cur = map->first(map); cur != NULL; cur = map->next(map) ) {
        printf(" %s=%d\n", cur->key, cur->value);
    }

    printf("\nIterate backwards\n");
    for(cur = map->last(map); cur != NULL; cur = map->next(map) ) {
        printf(" %s=%d\n", cur->key, cur->value);
    }

    map->ksort(map);
    printf("\nSorted by key\n");
    map->dump(map);

    printf("\nSorted by value\n");
    map->vsort(map);
    map->dump(map);

    cur = map->first(map);
    printf("The smallest value is %s=%d\n", cur->key, cur->value);

    cur = map->last(map);
    printf("The largest value is %s=%d\n", cur->key, cur->value);

    Map_del(map);
}

