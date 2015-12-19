#!/usr/bin/python
import json
import pprint



SERVER_NUM = 4

def partition(filename):
    f = []
    for i in range(1, SERVER_NUM + 1):
        f.append(open(filename[:filename.rfind('.')] + '_' + str(i) + '.json', 'w'))

    with open(filename) as inputfile:
        for line in inputfile:
            entry = json.loads(line)
            if 'user_id' in entry:
                num = ord(entry['user_id'][0:1]) % SERVER_NUM
            elif 'business_id' in entry:
                num = ord(entry['business_id'][0:1]) % SERVER_NUM
            else:
                print 'Neither business_id nor user_id exists!'
                for i in range(1, SERVER_NUM + 1):
                    f[i].close()
                sys.exit(0)
            f[num].write(line)

    for i in range(1, SERVER_NUM + 1):
        f[i - 1].close()


if __name__ == "__main__":
    partition('yelp_academic_dataset_business.json')
    partition('yelp_academic_dataset_user.json')
    partition('yelp_academic_dataset_review.json')
    partition('yelp_academic_dataset_checkin.json')


