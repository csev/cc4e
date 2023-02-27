import math

class PointClass:

    # Class variables
    label = "point"

    # Instance variables
    def __init__(self, x, y):
        self.x = x
        self.y = y
        
    def dump(self):
        print('Object %s@%x x=%f y=%f' % (self.label, id(self),self.x,self.y))

    def origin(self):
        return math.sqrt(self.x*self.x+self.y*self.y)
        
pt = PointClass(4.0, 5.0)

PointClass.dump(pt)
print('Origin',pt.origin())

del(pt)

