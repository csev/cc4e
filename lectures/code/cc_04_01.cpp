#include <iostream>
#include <map>
using namespace std;

int main() {
    map<string, int> mp;

    cout << "Testing Map class\n";
    mp["z"] = 8;
    mp["z"] = 1;
    mp["y"] = 2;
    mp["b"] = 3;
    mp["a"] = 4;
    for (map<string, int>::iterator i = mp.begin(); i != mp.end(); ++i) {
        cout << i->first << " " << i->second << "\n";
    }

    cout << "z=" << (mp.find("z") != mp.end() ? mp["z"] : 42) << endl;
    cout << "x=" << (mp.find("x") != mp.end() ? mp["x"] : 42) << endl;

    cout << "\nIterate forwards\n";
    for (map<string, int>::iterator i = mp.begin(); i != mp.end(); ++i) {
        cout << "Key = " << i->first << ", Value = " << i->second << endl;
    }

    int max = INT_MIN;
    string max_key;
    for (map<string, int>::iterator i = mp.begin(); i != mp.end(); ++i) {
        if (i->second > max) {
            max = i->second;
            max_key = i->first;
        }
    }
    cout << "The largest value is " << max_key << "=" << max << endl;

    return 0;
}

// rm -f a.out; g++ -Wc++11-extensions cc_04_01.cpp; a.out; rm -f a.out
