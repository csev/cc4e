def func(a, b):
    a = 1
    return(a, b)

x = 42
y = 43
print('main x',x,'y',y);
(x, y) = func(x, y)
print('back x',x,'y',y);

