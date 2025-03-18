use strict;
use warnings;
use LWP::UserAgent;
use JSON;

my $api_key = "20a7b658a2dba0ebfae0d6b17994e642";

print "Enter a city name: ";
chomp(my $city = <STDIN>);

$city =~ s/ /%20/g;

my $url = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$api_key&units=metric";

my $ua = LWP::UserAgent->new();
my $response = $ua->get($url);

if ($response->is_success) {
    my $weather_data = decode_json($response->decoded_content);
    
    if (exists $weather_data->{main}) {
        my $temperature = $weather_data->{main}->{temp};
        my $weather = $weather_data->{weather}->[0]->{description};
        
        print "\nWeather in $city:\n";
        print "Temperature: $temperature°C\n";
        print "Condition: $weather\n";
    } else {
        print "Error: City not found! Please check your input.\n";
    }
} else {
    print "Failed to get weather data: " . $response->status_line . "\n";
}

print "\nPress Enter to exit...";
<STDIN>;
