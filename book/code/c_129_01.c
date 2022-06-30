main() /* count C keywords; pointer version */
{
    int t;
    char word[MAXWORD];
    struct key *binary(), *p;

    while ((t = getword(word, MAXWORD)) != EOF)
        if (t == LETTER)
            if ((p=binary(word, keytab, NKEYS)) != NULL)
                p->keycount++;
    for (p = keytab; p < keytab + NKEYS; p++)
        if (p->keycount > 0)
            printf("%4d %s\n", p->keycount, p->keyword);
}

struct key *binary(word, tab, n) /* find word */
char *word; /* in tab[0]...tab[n-1] */
struct key tab[];
int n;
{
    int cond;

    struct key *low = &tab[0];
    struct key *high = &tab[n-1];
    struct key *mid;

    while (low <= high) {
        mid = low + (high-low) / 2;
        if ((cond = strcmp(word, mid->keyword)) < 0)
            high = mid - 1;
        else if (cond > 0)
            low = mid + 1;
        else
            return (mid);
    }
    return(NULL);
}

