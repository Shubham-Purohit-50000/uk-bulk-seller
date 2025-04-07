Workflow :

create RM today attendence option {present, absent}

compare the salesman's location before allowing a visit. (50 meter) if he is in radius then only allow him store visit.


Instead of relying on manual start/stop,
 geotracking should start automatically when the salesman enters a store radius and stop when they leave.

    * Store visit starts when salesman enters a store radius (e.g., within 50 meters).
    * Visit ends when salesman exits the radius for a defined period (e.g., 5 minutes).
    * Use a cron job or scheduled job to track real-time location updates.

Calculate Actual Time Spent in Store
    * Track entry time and exit time.
    * If a salesman leaves the store but stays nearby, pause the visit instead of stopping it.
    Logic 
    * When visit_time is recorded, keep tracking last_tracked_time via geolocation updates.
    * If no movement is detected for 5-10 minutes outside the store, end the visit and log visit_duration.

Detect Fake or Short Visits
    * If a salesman spends less than 5 minutes at a store, it’s likely a fake visit.
    * If they check in but never move, mark it as an invalid visit.

Summary

Final Fraud Prevention Features

1. GPS Validation Before Check-in
Uses Haversine formula to check store proximity before allowing visits.

2. Real-time Tracking with Pusher
Tracks salesman movement live.
Auto-ends visits if salesman leaves store for more than 5 minutes.

3. Auto-End Fake Visits.
If salesman doesn’t move for 10 minutes, visit is flagged and auto-ended.

4. Daily Admin Reports
Shows time spent, missed visits, and fake visits to admins.


Follow-up : 
Introduction of company, offer, intrested, intrested, app-downloaded, accounted created, 




I have table attendences (id,user_id[relational-maneger],date[date],check_in[timestamp],check_out['timestamp],status[present, leave]) and 
geo_trackings('user_id', 'latitude', 'longitude', 'attendence_id')

now In below code at detail() function section I want to display calander with present as green and other red.
and also when admin click on date display it traveled path on map with geo_trackings data.



Meeting : 23-02-2025

* give a option to upload comp-price proof.
* display price change by which user for cart items.







Data 07-03-2025

give option to edit franchise
display company franchise in backend.

create product variations




Date : 11-03-2025

give an option in product to add vat in % default 20,
give cart quantity option.
display relational-manager : contact no under account details,


After production :
add fcm to admin while bargan-cart



Rough  Date 29-03-2025 :
    remove quick view from shop,
    remove compare,
    



Pending Task : 30-03-2025
    header and footer links     #done
    mobile version header and footer.   #done
    make /test as home page     #done
    give RM option to register store.
    remove lang-country from top header. #done
    in /test set product slider for mobile version. #done
    Update cart and add to cart. #done
    add option to update quantity in view cart sidebar. #done
    add proof option in view have multiple image option.
    Header Product search.

    In Admin :
    give option vat default 20%
    in bargained amount will display till amount for that product till it not changed.



