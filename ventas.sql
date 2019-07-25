create table cliente
(
    login       varchar(30) primary key not null,
    password    varchar(20)             not null,
    nombres     varchar(40)             not null,
    apellidos   varchar(40)             not null,
    direccion   varchar(40)             not null,
    telefono    varchar(11)             not null,
    email       varchar(30)             not null,
    id_tipo_usu int                     not null
);

create table tipo_usu
(
    id     int primary key auto_increment not null,
    nombre varchar(30)                    not null
);

create table producto
(
    codigo      varchar(10) not null primary key,
    descripcion varchar(50) not null,
    precio      float       not null,
    cantidad    int         not null,
    stock       int         not null
);

create table venta
(
    numero_venta int         not null primary key auto_increment,
    fecha        date        not null,
    total        float       not null,
    login        varchar(30) not null,
    deposito     varchar(20) not null
);

create table detalle
(
    numero_detalle int         not null primary key auto_increment,
    numero_venta   int         not null,
    cantidad       int         not null,
    codigo         varchar(10) not null
);
alter table cliente
    add constraint idtipousu_tipousu foreign key (id_tipo_usu) references tipo_usu (id) on update restrict on delete restrict;

alter table venta
    add constraint ventlogin_clielogin foreign key (login) references cliente (login) on update restrict on delete restrict;

alter table detalle
    add constraint detallnumvent_ventnumvent foreign key (numero_venta) references venta (numero_venta) on update restrict on delete restrict,
    add constraint detallcodig_produccodi foreign key (codigo) references producto (codigo) on update restrict on delete restrict;

insert into producto(codigo, descripcion, precio, cantidad, stock)
VALUES ('TE0001', 'Teclado BTC', 6.5, 20, 20),
('TE0002', 'Teclado Multimedia PS2', 8, 10, 10),
('HD0001', 'Disco Duro Maxtor 80GB', 57, 30, 30),
('HD0002', 'Disco Duro 160GB', 90, 20, 20),
('MS0001', 'Mouse PS2 Genius', 4, 50, 50),
('MS0002', 'Mouse Optico Genius', 5, 50, 50),
('MO0001', 'Monitor LG Flatron', 90, 20, 20),
('MO0002', 'Monitor LG LCD', 280, 20, 20),
('PR0001', 'Impresora HP 3650', 55, 15, 15),
('PR0002', 'Impresora HP 3820', 80, 10, 10);

INSERT INTO tipo_usu (id, nombre)
VALUES (1, 'cliente'),
(2, 'admin');
