int main(void)
{
    struct pydict * dct = pydict_new();

    dct->put(dct, "z", "Catch phrase");
    dct->put(dct, "z", "W");

    printf("Length =%d\n",dct->len(dct));

    printf("z=%s\n", dct->get(dct, "z"));

    dct->del(dct);
}

