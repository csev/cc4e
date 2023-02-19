void func(ref int a)
{
    a = 1;
}

int x = 1;
Console.WriteLine(x);
func(ref x);
Console.WriteLine(x);
