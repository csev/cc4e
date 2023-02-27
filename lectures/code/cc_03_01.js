function Point(x, y) {
    this.x = x;
    this.y = y;
    this.party = function () {
        this.x = this.x + 1;
        console.log("So far "+this.x);
    }

    this.dump = function () {
        console.log("Object point x=%f y=%f", this.x, this.y);
    }

    this.origin = function () {
        return Math.sqrt(this.x*this.x+this.y*this.y);
    }
}

pt = new Point(4.0, 5.0);

pt.dump();
console.log("Origin %f",pt.origin());

// node cc_03_01.js
