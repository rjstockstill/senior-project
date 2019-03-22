import json

counter = 0
output_data = {}
output_data['item'] = []


for x in range(1): #change to 7 for all files
  filename1 = 'drug-label-000'
  filenumber = str(x + 1)
  filename2 = '-of-0007.json'
  finalfilename = filename1 + filenumber + filename2
  with open(finalfilename) as json_file:
    data = json.load(json_file)
    for p in data['results']:
      manufacturer = 'NONE'
      generic_name = 'NONE'
      brand_name = 'NONE'
      route = 'NONE'
      dosage = 'NONE'
      adverse_reactions = 'NONE'
      mechanism_of_action = 'NONE'
      warnings = 'NONE'

      if 'manufacturer_name' in p['openfda']:
        manufacturer = p['openfda']['manufacturer_name'][0]
      if 'generic_name' in p['openfda']:
        generic_name = p['openfda']['generic_name'][0]
      if 'brand_name' in p['openfda']:
        brand_name = p['openfda']['brand_name'][0]
      if 'route' in p['openfda']:
        route = p['openfda']['route'][0]
      if 'dosage' in p:
        dosage = p['dosage_and_administration'][0]
      if 'adverse_reactions' in p:
        adverse_reactions = p['adverse_reactions'][0]
      if 'mechanism_of_action' in p:
        mechanism_of_action = p['mechanism_of_action'][0]
      if 'warnings' in p:
        warnings = p['warnings'][0]
    
      print('manufacturer: ' + manufacturer)
      print('generic_name: ' + generic_name)
      print('brand_name: ' + brand_name)
      print('route: ' + route)
      print('dosage: ' + dosage)
      print('adverse_reactions: ' + adverse_reactions)
      print('mechanism_of_action: ' + mechanism_of_action)
      print('warnings: ' + warnings)
      print('')
    
      output_data['item'].append({
        'manufacturer': manufacturer,
        'generic_name': generic_name,
        'brand_name': brand_name,
        'route': route,
        'dosage': dosage,
        'adverse_reactions': adverse_reactions,
        'mechanism_of_action': mechanism_of_action,
        'warnings': warnings
      })
      counter += 1




print('TOTAL ENTRIES: ', counter)
with open('data.json', 'w') as output_file:
  json.dump(output_data, output_file)