import sys
import csv
import json

fname = sys.argv[1]
output = sys.argv[2]

json_dict = {'type':'FeatureCollection', 'features':[]}
with open(fname, 'rb') as csvfile:
    reader = csv.reader(csvfile)
    for row in reader:
        if len(row) != 6:
            continue
        try:
            place_name = row[0]
            lat = float(row[1])
            lng = float(row[2])
            place_type = row[3]
            age_start = int(row[4])
            age_end = int(row[5])
        except ValueError:
            continue
        row_dict = {}
        row_dict['type'] = "Feature"
        row_dict['geometry'] = {
                'type': "Point",
                'coordinates': [lng, lat]
            }
        row_dict['properties'] = {
                'name': place_name,
                'type': place_type,
                'start': age_start,
                'end': age_end
            }
        json_dict['features'].append(row_dict)
json_str = json.dumps(json_dict)
with open(output, 'w') as outputfile:
    outputfile.write(json_str)
    outputfile.close()
