import uuid
import os
import time
import datetime
import json

# Python 3

class Parallelbug:
	dir = None
	settings = {
		"format": "json",
		"meta": True,
		"meta_key": "__meta__",
		"date_format": "%Y-%m-%d %H:%M:%S",
		"append": False,
		"data_key": "dump",
		"append_group_key": "__append_group__"
	}

	@staticmethod
	def dump(data, opts):
		if(Parallelbug.dir is None):
			return False

		#Default params
		settings = dict(Parallelbug.settings)
		settings["filename"] = str(uuid.uuid4())

		opts = dict(list(settings.items()) + list(opts.items()))

		filename = os.path.join(Parallelbug.dir, opts["filename"])

		if(opts["meta"] == True):
			now = time.time()
			if(type(data) is dict or type(data) is list or type(data) is str):
				length = len(data)
			else:
				length = None

			data = {
				opts["meta_key"]: {
					"length": length,
					"type": type(data).__name__,
					"timestamp": now,
					"timestamp_pretty": datetime.datetime.fromtimestamp(now).strftime(opts["date_format"])
				},

				opts["data_key"]: data
			}

		if(opts["format"] == "json"):
			filename += ".json"

			if(opts["append"] == True):
				with open(filename) as infile:
				    old_data = json.load(infile)

				if(type(old_data) is list and opts["append_group_key"] in old_data):
					tmp = old_data
					tmp.append(data)
					data = tmp
				else:
					tmp = [
						opts["append_group_key"],
						old_data,
						data
					]
					data = tmp

			with open(filename, 'w') as outfile:
  				json.dump(data, outfile)