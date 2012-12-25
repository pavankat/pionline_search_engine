I replicated pionline.com's search engine using their API. 

This code is live [here](http://venturelateral.com/pi_candidate_project/search.php).

I chose to use javaScript, jQuery and PHP because I knew how $_GET, simplexml_load_file and xpath worked in PHP, and how window.location.href worked in javaScript. 

Code Explanation: 
In search.js you'll see that I wrote a custom function to redirect the user based on what sort button they pressed (date or relevance). I made it so that if sort=date or sort=rel is in the URL, the corresponding sort button would be disabled. In addition, I made it so that if an option was selected, the user would be redirected to that value and the corresponding option would be selected after the search was done. I also, redirected the user based on what option they picked, and that option stays selected after the search. 

In style.css you'll see how I styled the page. I tried my best to keep everything intuitive, and easy on the eyes. 

In search.php you'll see that I used Xpath to query the API. In addition, I made it so that the search value would appear in the input search box after the search has been made. I also, created my own pagination dropdown. 

Note: When I used xpath to get the data from the API, I noticed that the results returned were the same if the URL was http://venturelateral.com/pi_candidate_project/search.php?q=bankingνm=20&start=20 or http://venturelateral.com/pi_candidate_project/search.php?q=bankingνm=20&start=40. I thought this was something wrong with my code, but I made sure I looked at the API documentation and it seemed that &start=20 and &start=40 were correct. I then went to http://search.pionline.com/search/?q=banking&start=20νm=30&sort=rel&printXML=true and http://search.pionline.com/search/?q=banking&start=40νm=30&sort=rel&printXML=true. What I saw on both pages were very similar, so I'm not sure what to make of that. 