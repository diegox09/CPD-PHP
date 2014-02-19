#encoding:utf-8 
from django.forms import ModelForm
from django import forms
from principal.models import Tercero, Contrato, Pago

class ContactoForm(forms.Form):
	correo = forms.EmailField(label='Tu correo electrónico')
	mensaje = forms.CharField(widget=forms.Textarea)

class TerceroForm(ModelForm):
    class Meta:
        model = Tercero

class ContratoForm(ModelForm):
    class Meta:
        model = Contrato

class PagoForm(ModelForm):
    class Meta:
        model = Pago
