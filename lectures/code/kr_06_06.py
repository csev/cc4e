
lines = list()
hand = open('romeo.txt')
for line in hand:
    lines.append(line.rstrip())

lines.reverse()
for line in lines:
    print(line)

