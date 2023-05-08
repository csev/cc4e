int main(void)
{
    struct Map * map = Map_new();
    struct MapEntry *cur;
    struct MapIter *iter;

    printf("Map test\n");
    map->put(map, "z", 8);
    map->put(map, "z", 1);
    map->put(map, "y", 2);
    map->put(map, "b", 3);
    map->put(map, "a", 4);
    map->dump(map);

    printf("z=%d\n", map->get(map, "z", 42));
    printf("x=%d\n", map->get(map, "x", 42));

    printf("\nIterate\n");
    iter = map->iter(map);
    while(1) {
        cur = iter->next(iter);
        if ( cur == NULL ) break;
	    printf("%s=%d\n", cur->key, cur->value);
    }
    iter->del(iter);

    map->del(map);
}

// This does not compile - it needs a bunch of library code
