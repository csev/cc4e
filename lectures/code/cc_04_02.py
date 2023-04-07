x = dict()
x[1] = 40
print('print x[1]', x.__getitem__(1))

# x[5] = x[1] +2
x.__setitem__(5, x.__getitem__(1) + 2)
print(x)
