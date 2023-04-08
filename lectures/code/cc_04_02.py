import math

class Point:
    __x = 0.0
    __y = 0.0

    def __init__(self, x, y):
        self.__x = x
        self.__y = y

    def dump(self):
        print('Object point@%x x=%f y=%f' % (id(self),self.__x,self.__y))

pt = Point(4.0, 5.0)
Point.dump(pt)
del(pt)
