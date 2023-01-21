import math

class Point:
    def __init__(self, x, y):
        self.x = x
        self.y = y
        
    def dump(self):
        print('Object point@%x x=%f y=%f' % (id(self),self.x,self.y))

    def origin(self):
        return math.sqrt(self.x*self.x+self.y*self.y)
        
pt = Point(4.0, 5.0)
pt.dump()
print('Origin',pt.origin())
print('Origin',Point.origin(pt))


