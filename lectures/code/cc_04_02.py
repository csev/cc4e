x = {'a': 1, 'b': 2, 'c': 3}
print('x is', x)

y = list(x)
print('y is', y)

z = iter(x)
print('z is', z)

while True :
    item = next(z, False)
    if item is False : break
    print('item is', item)
