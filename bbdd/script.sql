			
CREATE TABLE dietas(idDieta integer primary key autoincrement, nombreDieta text not null,tipoDieta text not null, 
			descripcionDieta text not null, observacionesDieta text);
			
CREATE TABLE imagenes(idImagen integer primary key autoincrement, img blob);

CREATE TABLE clases(idClase integer primary key autoincrement, nombreClase text not null, nivel integer not null,
			diaSemana text not null, horaInicio text not null, horaFin text not null);
			
CREATE TABLE ejercicios(idEj integer primary key autoincrement, nombreEj text not null, 
		zonaTrabajada text not null, intensidad text not null);
			
CREATE TABLE usuarios(id integer primary key autoincrement, nombre text not null, apellidos text not null, 
		nick text not null unique, contrasegna text not null, correo text, telefono text, fechaNacimiento date,
		idDieta integer, idImagen integer,
		foreign key(idDieta) references dietas(idDieta),
		foreign key(idImagen) references imagenes(idImagen));
		
			
CREATE TABLE usuarios_ejercicios(id integer, idEj integer, fechaRealizado date, peso double, series integer,
		foreign key(id) references usuarios(id),
		foreign key(idEj) references ejercicios(idEj));
						
CREATE TABLE usuarios_clases(id integer, idClase integer, 
			foreign key(id) references usuarios(id), 
			foreign key(idClase) references clases(idClase));
			
			
			
				
INSERT INTO dietas VALUES(1, 'Dieta Hipocalorica', 'hipocalorica', 'Una dieta hipocalórica es una dieta para perder peso en la que se busca consumir menos calorías de las que necesita el cuerpo para “funcionar”.\nLos alimentos que podemos tomar en esta dieta son fruta, verdura, pescado. carne, en definitiva productos frescos. En cambio no hay que tomar alimentos que tengan pocas vitaminas y minerales, estos alimentos suelen ser muy ricos en azucar.Tampoco hay que tomar alimentos ultraprocesados.\n', 'Esta dieta tiene la creencia de que algunos alimentos light no son tan malos para nuestro cuerpo. Sin embargo que un alimento sea light no quiere decir que tenga menos calorías. Tampoco debemos comer mayor cantidad de un alimento porque éste sea light.');
INSERT INTO dietas VALUES (2, 'Dieta por Puntos', 'por puntos', 'La dieta de los puntos es una dieta flexible y que permite comer prácticamente de todo, ya que no te limita a variedad de comida sino que te hace calcular el máximo de puntos.\n Para que la dieta tenga éxito no debemos superar los puntos que nos han asignado. ', 'Para calcular los puntos que te corresponden debes sumar los siguientes parámetros:\n ');
INSERT INTO dietas VALUES (3, 'Dieta Paleo', 'paleo', 'La dieta paleo se basa en que estamos genéticamente adaptados para comer lo que comían nuestros antepasados del Paleolítico: carne, verduras, pescado, frutas…, y es mejor evitar lácteos, legumbres y cereales.', 'Es un tipo de dieta que ayuda a perder peso o a mantenerte en él, aumenta la sensación de saciedad, previene de enfermedades y nos proporciona un mejor descanso.');
INSERT INTO dietas VALUES (4, 'Dieta proteica', 'proteica', 'La dieta proteica consiste en un aumento considerable en la ingesta de proteínas disminuyendo notoriamente los carbohidratos y los lípidos.\nCada comida que se haga durante el día debe incluir un alimento proteico, y lo más destacable es que las calorías deben disminuirse progresivamente para que el cuerpo no sufra un impacto que ocasione estrés, carencias nutricionales, y lo más temido por todos, el efecto rebote.','-Esta dieta es para un tiempo determinado que no debe superar un mes sin extenderseya que se puede poner en riesgo la salud.\n-La dieta proteica no es para todas las personas, mucho menos para aquellas quesufren de insuficiencias renales, diabetes, hipertensión o personas con obesidad.');
INSERT INTO dietas VALUES (5, 'Dieta detox', 'detox', 'La dieta detox es un método alimenticio que consiste en ayudar a eliminar de nuestro cuerpo todo aquello que no necesita, con el objetivo de que su funcionamiento sea mucho más eficiente.', 'Si sigues la dieta detox podrás obtener los siguientes beneficios: perder peso, limpiar tu piel e hidratarla, oxigenar el cerebro, reducir el cansancio, mejorar descanso y mejorar el tránsito intestinal.');
				
				
				
INSERT INTO ejercicios VALUES (1, 'futbol', 'todo el cuerpo', 'alta');
INSERT INTO ejercicios VALUES (2, 'baloncesto', 'todo el cuerpo', 'alta');
INSERT INTO ejercicios VALUES (3, 'tenis', 'todo el cuerpo', 'alta');
INSERT INTO ejercicios VALUES (4, 'padel', 'todo el cuerpo', 'alta');
INSERT INTO ejercicios VALUES (5, 'natacion', 'todo el cuerpo', 'alta');
INSERT INTO ejercicios VALUES (6, 'sentadillas', 'pierna', 'alta');
INSERT INTO ejercicios VALUES (7, 'zancadas alternas', 'pierna', 'media');
INSERT INTO ejercicios VALUES (8, 'burpees', 'pierna', 'alta');
INSERT INTO ejercicios VALUES (9, 'puente', 'pierna', 'baja');
INSERT INTO ejercicios VALUES (10, 'gemelos', 'pierna', 'media');
INSERT INTO ejercicios VALUES (11, 'dominadas', 'espalda', 'alta');
INSERT INTO ejercicios VALUES (12, 'remo con barra', 'espalda', 'media');
INSERT INTO ejercicios VALUES (13, 'remo con mancuernas', 'espalda', 'baja');
INSERT INTO ejercicios VALUES (14, 'peso muerto', 'espalda', 'media');
INSERT INTO ejercicios VALUES (15, 'remo con polea baja', 'espalda', 'baja');
INSERT INTO ejercicios VALUES (16, 'mancuernas al pecho', 'pecho', 'alta');
INSERT INTO ejercicios VALUES (17, 'press banca inclinado', 'pecho', 'media');
INSERT INTO ejercicios VALUES (18, 'flexiones', 'pecho', 'media');
INSERT INTO ejercicios VALUES (19, 'aleteo con poleas', 'pecho', 'baja');
INSERT INTO ejercicios VALUES (20, 'mancuernas tumbado', 'pecho', 'media');
INSERT INTO ejercicios VALUES (21, 'curl de biceps', 'brazo', 'alta');
INSERT INTO ejercicios VALUES (22, 'dip de triceps', 'brazo', 'media');
INSERT INTO ejercicios VALUES (23, 'triceps detras de la nuca', 'brazo', 'baja');
INSERT INTO ejercicios VALUES (24, 'biceps con mancuerna sentado', 'brazo', 'alta');
INSERT INTO ejercicios VALUES (25, 'press de hombro', 'brazo', 'media');




INSERT INTO clases VALUES (1, 'ciclo', 2, 'lunes', '08:00', '09:00');
INSERT INTO clases VALUES (2, 'body pump', 3, 'lunes', '09:30', '10:15');
INSERT INTO clases VALUES (3, 'zumba', 2, 'lunes', '10:30', '11:30');
INSERT INTO clases VALUES (4, 'body balance', 1, 'lunes', '12:00', '12:45');
INSERT INTO clases VALUES (5, 'yoga', 1, 'lunes', '13:00', '13:45');
INSERT INTO clases VALUES (6, 'pilates', 1, 'lunes', '16:00', '16:45');
INSERT INTO clases VALUES (7, 'gap', 2, 'lunes', '17:00', '17:45');
INSERT INTO clases VALUES (8, 'body combat', 3, 'lunes', '18:00', '18:45');
INSERT INTO clases VALUES (9, 'zumba', 2, 'lunes', '19:00', '19:45');
INSERT INTO clases VALUES (10, 'body pump', 3, 'lunes', '20:00', '20:45');
INSERT INTO clases VALUES (11, 'ciclo', 2, 'lunes', '21:00', '22:00');
INSERT INTO clases VALUES (12, 'pilates', 1, 'martes', '08:00', '09:00');
INSERT INTO clases VALUES (13, 'yoga', 1, 'martes', '09:15', '10:00');
INSERT INTO clases VALUES (14, 'body pump', 3, 'martes', '10:15', '11:00');
INSERT INTO clases VALUES (15, 'gap', 2, 'martes', '11:45', '12:30');
INSERT INTO clases VALUES (16, 'espalda sana', 1, 'martes', '13:00', '13:45');
INSERT INTO clases VALUES (17, 'espalda sana', 1, 'martes', '16:00', '16:45');
INSERT INTO clases VALUES (18, 'yoga', 1, 'martes', '17:00', '17:45');
INSERT INTO clases VALUES (19, 'body combat', 3, 'martes', '18:00', '18:45');
INSERT INTO clases VALUES (20, 'pilates', 1, 'martes', '19:00', '19:45');
INSERT INTO clases VALUES (21, 'gap', 2, 'martes', '20:00', '20:45');
INSERT INTO clases VALUES (22, 'body pump', 3, 'martes', '21:00', '21:45');
INSERT INTO clases VALUES (23, 'yoga', 1, 'miercoles', '08:00', '09:00');
INSERT INTO clases VALUES (24, 'zumba', 2, 'miercoles', '09:15', '10:00');
INSERT INTO clases VALUES (25, 'pilates', 1, 'miercoles', '10:15', '11:00');
INSERT INTO clases VALUES (26, 'body combat', 3, 'miercoles', '11:15', '12:15');
INSERT INTO clases VALUES (27, 'ciclo', 2, 'miercoles', '12:45', '13:45');
INSERT INTO clases VALUES (28, 'yoga', 1, 'miercoles', '16:00', '16:45');
INSERT INTO clases VALUES (29, 'pilates', 1, 'miercoles', '17:00', '17:45');
INSERT INTO clases VALUES (30, 'body pump', 3, 'miercoles', '18:00', '18:45');
INSERT INTO clases VALUES (31, 'gap', 2, 'miercoles', '19:00', '19:45');
INSERT INTO clases VALUES (32, 'espalda sana', 1, 'miercoles', '20:00', '20:45');
INSERT INTO clases VALUES (33, 'body combat', 3, 'miercoles', '21:00', '21:45');
INSERT INTO clases VALUES (34, 'ciclo', 2, 'jueves', '08:00', '09:00');
INSERT INTO clases VALUES (35, 'gap', 2, 'jueves', '09:15', '10:00');
INSERT INTO clases VALUES (36, 'espalda sana', 1, 'jueves', '10:15', '11:00');
INSERT INTO clases VALUES (37, 'body pump', 3, 'jueves', '11:30', '12:30');
INSERT INTO clases VALUES (38, 'pilates', 1, 'jueves', '12:45', '13:30');
INSERT INTO clases VALUES (39, 'zumba', 2, 'jueves', '16:00', '16:45');
INSERT INTO clases VALUES (40, 'espalda sana', 2, 'jueves', '17:00', '17:45');
INSERT INTO clases VALUES (41, 'ciclo', 2, 'jueves', '18:00', '18:45');
INSERT INTO clases VALUES (42, 'gap', 2, 'jueves', '19:00', '19:45');
INSERT INTO clases VALUES (43, 'body combat', 3, 'jueves', '20:00', '20:45');
INSERT INTO clases VALUES (44, 'body pump', 3, 'jueves', '21:00', '21:45');
INSERT INTO clases VALUES (45, 'ciclo', 2, 'viernes', '08:00', '09:00');
INSERT INTO clases VALUES (46, 'pilates', 1, 'viernes', '09:15', '10:00');
INSERT INTO clases VALUES (47, 'espalda sana', 1, 'viernes', '10:15', '11:15');
INSERT INTO clases VALUES (48, 'gap', 2, 'viernes', '11:30', '12:30');
INSERT INTO clases VALUES (49, 'body pump', 3, 'viernes', '12:45', '13:30');
INSERT INTO clases VALUES (50, 'ciclo', 2, 'viernes', '16:00', '16:45');
INSERT INTO clases VALUES (51, 'espalda sana', 1, 'viernes', '17:00', '17:45');
INSERT INTO clases VALUES (52, 'body combat', 3, 'viernes', '18:00', '18:45');
INSERT INTO clases VALUES (53, 'gap', 2, 'viernes', '19:00', '19:45');
INSERT INTO clases VALUES (54, 'yoga', 1, 'viernes', '20:00', '20:45');
INSERT INTO clases VALUES (55, 'body pump', 3, 'viernes', '21:00', '21:45');
INSERT INTO clases VALUES (56, 'yoga', 1, 'sabado', '09:00', '09:45');
INSERT INTO clases VALUES (57, 'gap', 2, 'sabado', '10:00', '10:45');
INSERT INTO clases VALUES (58, 'ciclo', 2, 'sabado', '11:00', '11:45');
INSERT INTO clases VALUES (59, 'body pump', 3, 'sabado', '12:00', '12:45');
INSERT INTO clases VALUES (60, 'body combat', 3, 'sabado', '13:00', '13:45');
INSERT INTO clases VALUES (61, 'espalda sana', 1, 'domingo', '09:00', '09:45');
INSERT INTO clases VALUES (62, 'pilates', 1, 'domingo', '10:00', '10:45');
INSERT INTO clases VALUES (63, 'zumba', 2, 'domingo', '11:00', '11:45');
INSERT INTO clases VALUES (64, 'gap', 2, 'domingo', '12:00', '12:45');
INSERT INTO clases VALUES (65, 'body pump', 3, 'domingo', '13:00', '13:45');














			

		
