create table T_medicamentos (
    codMedicamento number(6),
    nombre varchar2(50) not NULL,
    descripcion varchar2(200) not NULL,
    precio number(6,2) not NULL,
    stock number(4) default 0 not NULL,
    constraint pk_medicamentos primary key (codMedicamento),
    constraint ck_medic_cod check (codMedicamento >= 0),
    constarint ck_precio check (precio >= 0),
    constarint ck_stock check (stock > 0)
);

create table T_medicos(
    NIF number(6),
    nombre varchar2(25) not NULL,
    apellido1 varchar2(200) not NULL,
    apellido2 varchar2(200),
    fechaNacimiento date not NULL,
    especialidad varchar2(10) not NULL,
    provincia varchar2(50) not NULL,
    sueldo number(6,2) not NULL,
    constarint pk_medicos primary key (NIF),
    constarint ck_medicos_cod check (sueldo >= 100)
);

create table T_pacientes(
    dni number(9),
    nombre varchar2(25) not NULL,
    apellido1 varchar2(200) not NULL,
    apellido2 varchar2(200),
    fechaNacimiento date not NULL,
    provincia varchar2(50) not NULL,
    telefono number(9) not NULL,
    constarint pk_pacientes primary key (dni),
    constarint ck_pacientes_cod check (telefono >= 100)
);

create table T_recetas(
    NIF_paciente VARCHAR(12),
    NIF_medico VARCHAR(12),
    codMedicamento number(6),
    fecha date not NULL,
    cantidad number(4) default 1 not NULL,
    constarint pk_recetas 
        primary key (NIF_paciente, NIF_medico, codMedicamento), fecha),
    constarint fk_recetas_pacientes 
        foreign key (NIF_paciente) references T_pacientes(dni),
    contraint fk_recetas_medicos
        foreign key (codMedicamento) references T_medicamentos(codMedicamento)
);

/* create view */
create view medicos AS select * from T_medicos;
create view pacientes AS select * from T_pacientes;
create view recetas AS select * from T_recetas;
create view medicamentos AS select * from T_medicamentos;
create view recetas_medicamentos AS select * from T_recetas;

/* creacion de roles */

create roll administrativo 
create roll Doctor
create roll peon
create roll administrador

grand insert, delete, update, select on medicamentos to administrativo;

grand select on medicamentos to Doctor;

grand insert, delete, update, select on medicamentos to peon;

grand select on medicamentos to peon;

grand insert, delete, update, select on medicamentos to administrador;