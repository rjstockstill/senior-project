import json



with open('data.json') as json_file:
  with open('insert.sql', 'w', encoding='utf-8') as output_file:
    data = json.load(json_file)
    for p in data['item']:
      output_file.write('INSERT INTO mls VALUES(\'' + p['manufacturer'] + '\', \'' + p['generic_name'] + '\', \'' + p['brand_name'] + '\', \'' + p['route'] + '\', \'' + p['dosage'] + '\', \'' + p['adverse_reactions'] + '\', \'' + p['mechanism_of_action'] + '\', \'' + p['warnings'] + '\');\n')