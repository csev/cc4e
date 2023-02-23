struct point
{
    double x;
    double y;
};

struct PointStruct {
    struct point * (*new)(double x, double y);
    void (*del)(const struct point* self);
    void (*dump)(const struct point* self);
    double (*origin)(const struct point* self);
};

struct PointStruct PointClass;

#define IMPORT_POINT extern struct PointStruct PointClass; void import_pointstruct(); import_pointstruct();

