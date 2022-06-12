swap(px, py) /* interchange *px and *py */
int *px, *py;
{
  int temp;

  temp = *px;
  *px = *py;
  *py = temp;
}
