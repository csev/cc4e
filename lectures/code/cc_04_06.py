x = {'a': 1, 'b': 2, 'c': 3}
print('x is', x)

y = list(x)
print('y is', y)

it = iter(x)
print('it is', it)

while True :
    item = next(it, False)
    if item is False : break
    print('item is', item)
