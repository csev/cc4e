power(x, n) /* raise x to n-th power; n > 0 */
int x, n;
{
    int i,p;

    for (p = 1; n > 0; --n)
        p = p * x;
    return (p);
}

