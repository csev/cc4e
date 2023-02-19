program kr_05_03;
var
   x, y : integer;

procedure func(a: integer; var b: integer);
begin
    a := 1;
    b := 2;
end;

begin
    x := 42;
    y := 43;
    writeln('main x ',x);
    writeln('main y ',y);
    func(x, y);
    writeln('back x ',x);
    writeln('back y ',y);
end.

(* https://www.onlinegdb.com/online_pascal_compiler *)
