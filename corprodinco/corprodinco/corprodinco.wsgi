import os
import sys
sys.path.append('/var/www/cpd/corprodinco/corprodinco')
os.environ['PYTHON_EGG_CACHE'] = '/var/www/cpd/corprodinco/.python-egg'
os.environ['DJANGO_SETTINGS_MODULE'] = 'settings'
import django.core.handlers.wsgi
application = django.core.handlers.wsgi.WSGIHandler()
