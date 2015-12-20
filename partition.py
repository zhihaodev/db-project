#!/usr/bin/python
import json
import pprint


SERVER_NUM = 4

# def djb2(uuid):
#     """DJB2 hash algorithm. Reference: https://gist.github.com/SaveTheRbtz/2117117 """

#     _hash = 5381
#     for i in xrange(0, len(uuid)):
#        _hash = ((_hash << 5) + _hash) + ord(uuid[i])
#     return _hash


def partition(filename):
    f = []
    for i in range(1, SERVER_NUM + 1):
        f.append(open(
            filename[:filename.rfind('.')] + '_' + str(i) + '.json',
            'w'))

    with open(filename) as inputfile:
        for line in inputfile:
            entry = json.loads(line)
            if 'user_id' in entry:
                num = ord(entry['user_id'][0:1]) % SERVER_NUM
                # num = djb2(entry['user_id'][:4]) % SERVER_NUM
            elif 'business_id' in entry:
                num = ord(entry['business_id'][0:1]) % SERVER_NUM
                # num = djb2(entry['business_id'][:4]) % SERVER_NUM
            else:
                print 'Neither business_id nor user_id exists!'
                break
            if 'checkin_info' in entry:
                days = [0 for i in range(0, 7)]
                for key in entry['checkin_info']:
                    days[int(key.split('-')[1])] += 1
                entry['checkin_info'] = {
                    'Mon': days[1], 'Tue': days[2],
                    'Wed': days[3], 'Thu': days[4],
                    'Fri': days[5], 'Sat': days[6],
                    'Sun': days[0]}
                f[num].write(json.dumps(entry))
                f[num].write('\n')
                continue
            if 'yelping_since' in entry:
                entry['yelping_since'] += '-00'
                f[num].write(json.dumps(entry))
                f[num].write('\n')
                continue
            f[num].write(line)

    for i in range(0, SERVER_NUM):
        f[i].close()


if __name__ == "__main__":
    # partition('yelp_academic_dataset_business.json')
    partition('yelp_academic_dataset_user.json')
    # partition('yelp_academic_dataset_review.json')
    # partition('yelp_academic_dataset_checkin.json')
