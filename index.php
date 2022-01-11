<?php
include 'MaxGraphQL.php';

use MaxGraphQL\Mutation;

$query = '
query {
    property(
      id: "17093355", 
      idSource: EXPEDIA
    )
    {
      promotions(
        pageSize: 20,
        filter: {
            id: "84fa4e08-612f-4052-a393-6c7f9911a270"
        }
      ) {
            edges {
            node {
                    id
                    name
                    status
                    ... on DiscountPromotion {
                        code
                        restrictions {
                            minLengthOfStay
                            maxLengthOfStay
                            minAdvanceBookingDays
                            maxAdvanceBookingDays
                            bookingLocalDateTimeFrom
                            bookingLocalDateTimeTo
                            travelDateFrom
                            travelDateTo
                        }
                              blackoutDates {

        travelDateFrom

        travelDateTo

      }
                        discount {
                            type
                            unit
                            ... on SingleDiscount {
                                value
                                memberOnlyAdditionalValue
                            }
                            ... on DayOfWeekDiscount {
                                monday
                                tuesday
                                wednesday
                                thursday
                                friday
                                saturday
                                sunday
                            }
                        }
                    }
                } 
            }
        }
    }
}';

$mutation = '
mutation {

    updateDayOfWeekDiscountPromotion(
  
      propertyId: "9309913",
  
      propertyIdSource: EXPEDIA,
  
      promotion: {
  
        id: "391035963",
  
        code: "Updated DOW",';


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apis.expediaconnectivity.com/graphql',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode(['query' => $query]),
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer eyJraWQiOiI5ZTY0MzdiZS02ODYzLTRjNTYtYWNhZC05YmJmMTkwYjllY2YiLCJhbGciOiJFUzUxMiJ9.eyJzdWIiOiI0MGRmMGRiNi0zM2NlLTQ3YmUtOTljOS00ODdiMGVjZThkZjQiLCJ2ZXIiOiIxLjAuMCIsImNsaWVudF91aWQiOiI2OTA0MDQwMCIsImlzcyI6Imh0dHBzOlwvXC9pZGVudGl0eS10b2tlbi1zZXJ2aWNlLnVzLXdlc3QtMi5wcm9kLmVndXNlci5leHBlZGlhLmNvbVwvdjJcL3Rva2VucyIsInR1aWQiOiI2OTA0MDQwMCIsImNsaWVudF9pZCI6IkVRQzE3MDkzMzU1aG90ZWwiLCJhdWQiOiIiLCJhY3IiOlsiQVVUSEVOVElDQVRFRCJdLCJzcGZtIjoiTFBTIiwibmJmIjoxNjQxODM3NjQyLCJpZHAiOiJscHMtY29ubiIsInByb2ZpbGVfaWQiOiI0MGRmMGRiNi0zM2NlLTQ3YmUtOTljOS00ODdiMGVjZThkZjQiLCJzY29wZSI6ImxvZGdpbmctc3VwcGx5LnJldmVudWUtbWFuYWdlbWVudC5nZXQgbG9kZ2luZy1zdXBwbHkuZ3JhcGhxbC5hcGkgbG9kZ2luZy1zdXBwbHkucHJvbW90aW9uLmFsbCBsb2RnaW5nLXN1cHBseS5wYXJyLmFwaSBsb2RnaW5nLXN1cHBseS5wcm9wZXJ0eS1zdGF0dXMuZ2V0IGxvZGdpbmctc3VwcGx5LnByb2R1Y3QuZ2V0IGxvZGdpbmctc3VwcGx5LmF2YWlsYWJpbGl0eS1yYXRlcy5hcGkgbG9kZ2luZy1zdXBwbHkuaW1hZ2UuYXBpIGxvZGdpbmctc3VwcGx5LnByb2R1Y3QuYWxsIGxvZGdpbmctc3VwcGx5LnByb21vdGlvbi5hcGkgbG9kZ2luZy1zdXBwbHkuZGVwb3NpdC5hbGwgbG9kZ2luZy1zdXBwbHkucmVndWxhdGlvbi5hbGwgbG9kZ2luZy1zdXBwbHkucHJvZHVjdC5hcGkgbG9kZ2luZy1zdXBwbHkuZGVwb3NpdC5hcGkgbG9kZ2luZy1zdXBwbHkuaW1hZ2UuYWxsIGxvZGdpbmctc3VwcGx5LmJvb2tpbmctcmV0cmlldmFsLmFwaSBsb2RnaW5nLXN1cHBseS5yZXNlcnZhdGlvbi5hbGwgbG9kZ2luZy1zdXBwbHkuaW52ZW50b3J5LmFsbCBsb2RnaW5nLXN1cHBseS5yZXNlcnZhdGlvbi1yZXN0cmljdGVkLmdldCIsImF1dGhfdGltZSI6MTY0MTgzNzY0NzI4OCwic2Vzc2lvbl9leHAiOjE2NDE4Mzk0NDcyODgsImFjdG9yX2lkIjoiNDBkZjBkYjYtMzNjZS00N2JlLTk5YzktNDg3YjBlY2U4ZGY0IiwiY2xpZW50X2lkcCI6Imxwcy1jb25uIiwiZXhwIjoxNjQxODM5NDQ3LCJpYXQiOjE2NDE4Mzc2NDcsImp0aSI6Ijg1ZmVkNjE1LTQwMDItNDJmZC04ZWFmLTNiMDMyNDUzZmE4MiJ9.AZHvtjWcqCK4mQJ7yg4Omv99L2BzFlf9RP1iuuKsQdmG4TYFNYQ3fy-kIrYq7kPsqy-dMzpJZZsDIBMmTUAwHSUPAZIpZO9kUJc6QcJ_lxRSIh4jkbta3OXNiOFLFmleI8wx3K3zSlSP4nLuxBmQwlPScJd9jHltaGDt2HzqvzHco7uI',
    'Content-Type: application/json',
    'Cookie: ak_bmsc=955465351F4533009365565095D2004C~000000000000000000000000000000~YAAQbVtgaEFYGqB9AQAAfxjRQw7JsEpIsWRzuHNpM44Y+45zHFvsy6OYGotbBcR6C6Aj8MbkO/XbhcTblGzPP8jC078DnYS0gTDNveVYBYLK/gRAxrkHDnzqdTP+lGIJKZYKJqdEaZqSaKbOdKQ3AR4iDzQlAqOg8inFghmHcRrUbFiy3DdEPuZVybLPa6Bf8TWht2ZvMHnsarsVp6EsC97s3kek9Rw3ahfpLZYyu/CgcoxixFqGrmnVBCiviyHzZpaX+/N9Rxwyt6co39EzfeR30Sz3KrWXRecLvqoYd/4bXsExh1wMUbqhqz6HV91LTEZZpS+g+6KjPwcBH7t1MSO8Ga6PDhjcay412mTDlDn3ISrw/nHsNHs3qJ/NrsYn2m4GUvqEldSJ; bm_sv=CFC9710C260F58366ADB1DAF04C82F2F~LYd/mUnjgXBRfNevJN0GNbeiArnZVsT6Rde4UuBShoKl9TZhUpAKcHE46jpizsnbNe5kVQRih9dK9wXJZLxsq0dtzrl55k3dw2DfvGDQM9cP2Ds9j+a5DozzUqawzC7nYCM5DePtf85bAKYJc0Lp46H1jEFjuzD95gsnWBgoZ5c='
  ),
));

$response = curl_exec($curl);

curl_close($curl);

$promo = json_decode($response, true);
echo '<pre>';
print_r($promo);


$form = [
    'code' => '123ste',
    'restrictions' => [
        'travelDateFrom' => '2022-01-13',
        'travelDateTo' => '2022-02-13',
    ],
    'blackoutDates' => [
        [
            'travelDateFrom' => '2022-01-15',
            'travelDateTo' => '2022-01-20'
        ]
    ]
];

$oldPromotion = $promo['data']['property']['promotions']['edges'][0]['node'];

$toBeUpdated = checkModify($form, $oldPromotion);

function checkModify(array $form, array $oldPromotion): array
{
    $toBeUpdated = [];

    foreach ($oldPromotion as $index => $value) {
        if (isset($form[$index])) {
            if (is_array($form[$index])) {
                foreach ($form[$index] as $formIndex => $formValue) {
                    if ($oldPromotion[$index][$formIndex] !== $form[$index][$formIndex]) {
                        $toBeUpdated[$index][$formIndex] = $formValue;
                    }
                }
            } else {
                if ($form[$index] !== $oldPromotion[$index]) {
                    $toBeUpdated[$index] = $form[$index];
                }
            }
        }
    }

    return $toBeUpdated;
}

$toBeUpdated['id'] = '84fa4e08-612f-4052-a393-6c7f9911a270';


print_r($toBeUpdated);
