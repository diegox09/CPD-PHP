#encoding:utf-8
from django.db import models
from django.contrib.auth.models import User

class Departamento(models.Model):	
    nombre_departamento = models.CharField(max_length=30, verbose_name='Nombre Departamento', unique=True)    
    tiempo_registro = models.DateTimeField(auto_now=True, blank=True)
    usuario = models.ForeignKey(User)
	
    def __unicode__(self):
        return self.nombre_departamento

class Municipio(models.Model):	
    nombre_municipio = models.CharField(max_length=30, verbose_name='Nombre Municipio', unique=True)
    departamento = models.ForeignKey(Departamento)
    tiempo_registro = models.DateTimeField(auto_now=True, blank=True)
    usuario = models.ForeignKey(User)
	
    def __unicode__(self):
        return self.nombre_municipio

class Barrio(models.Model):
    nombre_barrio = models.CharField(max_length=30, verbose_name='Nombre Barrio')    
    municipio = models.ForeignKey(Municipio)
    tiempo_registro = models.DateTimeField(auto_now=True, blank=True)
    usuario = models.ForeignKey(User)
	
    def __unicode__(self):
        return self.nombre_barrio

class Tercero(models.Model):
	DOCUMENTO_CHOICES = ( 
		('C', 'Cedula de Ciudadania'),
		('T', 'Tarjeta de Identidad'),
		('O', 'Otro'),
    )
	GENERO_CHOICES = (        
        ('F', 'Femenino'),
		('M', 'Masculino'),
    )
	tipo_documento = models.CharField(max_length=1, verbose_name='Tipo de Documento', choices=DOCUMENTO_CHOICES)
	numero_documento = models.CharField(max_length=12, verbose_name='Numero de Documento', unique=True)
	digito_verificacion = models.CharField(max_length=1, verbose_name='Digito de Verificacion', blank=True)
	fecha_expedicion = models.DateField(verbose_name='Fecha de Expedicion', blank=True)
	primer_nombre = models.CharField(max_length=15, verbose_name='Primer Nombre')
	otros_nombres = models.CharField(max_length=15, verbose_name='Otros Nombres', blank=True)
	primer_apellido = models.CharField(max_length=15, verbose_name='Primer Apellido')
	segundo_apellido = models.CharField(max_length=15, verbose_name='Segundo Apellido', blank=True)
	razon_social = models.CharField(max_length=60, verbose_name='Razon Social', blank=True)
	genero = models.CharField(max_length=1, verbose_name='Genero', choices=GENERO_CHOICES)
	fecha_nacimiento = models.DateField(verbose_name='Fecha de Nacimiento')
	telefono = models.CharField(max_length=10, verbose_name='Telefono', blank=True)
	celular = models.CharField(max_length=10, verbose_name='Celular', blank=True)
	email_personal = models.EmailField(verbose_name='Email Personal', blank=True)
	email_corporativo = models.EmailField(verbose_name='Email Corporativo', blank=True)
	skype = models.CharField(max_length=30, verbose_name='Skype', blank=True)
	direccion = models.CharField(max_length=50, verbose_name='Direccion', blank=True)
	barrio = models.ForeignKey(Barrio, blank=True)
	foto = models.ImageField(upload_to='fotos', verbose_name='Foto', blank=True)
	tiempo_registro = models.DateTimeField(auto_now=True, blank=True)
	usuario = models.ForeignKey(User)
	
	def __unicode__(self):
		return self.numero_documento
		
class Programa(models.Model):
    nombre_programa = models.CharField(max_length=40, verbose_name='Nombre Programa', unique=True)
    descripcion_programa = models.CharField(max_length=50, verbose_name='Descripcion Programa', blank=True)
    municipio = models.ForeignKey(Municipio)
    tiempo_registro = models.DateTimeField(auto_now=True, blank=True)
    usuario = models.ForeignKey(User)
	
    def __unicode__(self):
        return self.nombre_programa
		
class Cargo(models.Model):
    nombre_cargo = models.CharField(max_length=30, verbose_name='Nombre Cargo', unique=True)
    tiempo_registro = models.DateTimeField(auto_now=True, blank=True)
    usuario = models.ForeignKey(User)

    def __unicode__(self):
        return self.nombre_cargo

class Eps(models.Model):
    nombre_eps = models.CharField(max_length=30, verbose_name='Nombre EPS', unique=True)        
    tiempo_registro = models.DateTimeField(auto_now=True, blank=True)
    usuario = models.ForeignKey(User)
	
    def __unicode__(self):
        return self.nombre_eps

class Arp(models.Model):
    nombre_Arp = models.CharField(max_length=30, verbose_name='Nombre Arp', unique=True)       
    tiempo_registro = models.DateTimeField(auto_now=True, blank=True)
    usuario = models.ForeignKey(User)
	
    def __unicode__(self):
        return self.nombre_arp

class FondoPension(models.Model):
    nombre_fondo_pension = models.CharField(max_length=30, verbose_name='Nombre Fondo de Pension', unique=True)
    tiempo_registro = models.DateTimeField(auto_now=True, blank=True)
    usuario = models.ForeignKey(User)
	
    def __unicode__(self):
        return self.nombre_fondo_pension

class Banco(models.Model):
    nombre_banco = models.CharField(max_length=30, verbose_name='Nombre Banco', unique=True)
    tiempo_registro = models.DateTimeField(auto_now=True, blank=True)
    usuario = models.ForeignKey(User)
	
    def __unicode__(self):
        return self.nombre_banco			

class Contrato(models.Model):
    TIPO_CUENTA_CHOICES = ( 
        ('A', 'Ahorros'),
        ('C', 'Corriente'),		
    )
    MOTIVO_RETIRO_CHOICES = ( 
        ('1', 'Renuncia Voluntaria'),
        ('8', 'Abandono del Cargo'),
        ('9', 'Despido'),
    )
    consecutivo = models.CharField(max_length=15, verbose_name='Contrato', unique=True)
    municipio = models.ForeignKey(Municipio)
    programa = models.ForeignKey(Programa)
    cargo = models.ForeignKey(Cargo)    
    fecha_ingreso = models.DateField(verbose_name='Fecha de Ingreso')
    fecha_terminacion = models.DateField(verbose_name='Fecha de Terminacion')    
    eps = models.ForeignKey(Eps, blank=True)
    arp = models.ForeignKey(Arp, blank=True)
    fondo_pension = models.ForeignKey(FondoPension, blank=True)    
    valor_honorarios = models.BigIntegerField(verbose_name='Valor Honorarios')    
    observaciones = models.TextField(verbose_name='Observaciones', blank=True)
    banco = models.ForeignKey(Banco, blank=True)
    tipo_cuenta = models.CharField(max_length=1, verbose_name='Tipo de Cuenta', choices=TIPO_CUENTA_CHOICES, blank=True)
    numero_cuenta = models.CharField(max_length=15, verbose_name='Numero de Cuenta', blank=True)
    fecha_retiro = models.DateField(verbose_name='Fecha de Retiro', blank=True)
    motivo_retiro = models.CharField(max_length=1, verbose_name='Motivo de Retiro', choices=MOTIVO_RETIRO_CHOICES, blank=True)
    tiempo_registro = models.DateTimeField(auto_now=True, blank=True)
    usuario = models.ForeignKey(User)
    
    def __unicode__(self):
		return self.consecutivo
	
class Pago(models.Model):
    ESTADO_PAGO_CHOICES = ( 
        ('H', 'Habilitado'),
        ('A', 'Autorizado'),
        ('P', 'Pago'),
    )
    TIPO_PAGO_CHOICES = ( 
        ('H', 'Honorarios'),
        ('M', 'Movilidad'),
    )
    MES_CHOICES = ( 
        ('1', 'Enero'),
        ('2', 'Febrero'),
        ('3', 'Marzo'),
        ('4', 'Abril'),
        ('5', 'Mayo'),
        ('6', 'Junio'),
        ('7', 'Julio'),
        ('8', 'Agosto'),
        ('9', 'Septiembre'),
        ('10', 'Octubre'),
        ('11', 'Noviembre'),
        ('12', 'Diciembre'),
    )	
    contrato = models.ForeignKey(Contrato)
    estado_pago = models.CharField(max_length=1, verbose_name='Estado Pago', choices=ESTADO_PAGO_CHOICES, blank=True)    
    mes_pago = models.CharField(max_length=2, verbose_name='Mes', choices=MES_CHOICES)
    tipo_pago = models.CharField(max_length=1, verbose_name='Tipo Pago', choices=TIPO_PAGO_CHOICES)
    fecha_habilitacion = models.DateField(verbose_name='Fecha de Habilitacion')    
    dias_habilitados = models.DateField(verbose_name='Dias Habilitados', blank=True)
    valor_habilitado = models.BigIntegerField(verbose_name='Valor Habilitado')
    descuentos = models.BigIntegerField(verbose_name='Descuentos')
    reintegros = models.BigIntegerField(verbose_name='Reintegros')
    fecha_autorizacion = models.DateField(verbose_name='Fecha de Autorizacion', blank=True)
    valor_pagado = models.BigIntegerField(verbose_name='Valor Pagado')
    fecha_pago = models.DateField(verbose_name='Fecha de Pago', blank=True)
    observaciones = models.TextField(verbose_name='Observaciones', blank=True)
    tiempo_registro = models.DateTimeField(auto_now=True, blank=True)
    usuario = models.ForeignKey(User)
	
    def __unicode__(self):
		return self.valor_pagado	