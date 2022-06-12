swap(x, y)  /* WRONG */
int x, y;
{
  int temp;

  temp = x;
  x = y;
  y = temp;
}
