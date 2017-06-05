[![](https://scdn.rapidapi.com/RapidAPI_banner.png)](https://rapidapi.com/package/GoogleCloudSpeech/functions?utm_source=RapidAPIGitHub_GoogleCloudSpeechFunctions&utm_medium=button&utm_content=RapidAPI_GitHub)

# GoogleCloudSpeech Package
Convert audio to text with neural network models.
* Domain: [GoogleCloudSpeech](https://cloud.google.com/speech/)
* Credentials: apiKey, apiSecret

## How to get credentials: 
1. Get apiKey and apiSecret from Google Console when create application.


## Custom datatypes: 
|Datatype|Description|Example
|--------|-----------|----------
|Datepicker|String which includes date and time|```2016-05-28 00:00:00```
|Map|String which includes latitude and longitude coma separated|```50.37, 26.56```
|List|Simple array|```["123", "sample"]``` 
|Select|String with predefined values|```sample```
|Array|Array of objects|```[{"Second name":"123","Age":"12","Photo":"sdf","Draft":"sdfsdf"},{"name":"adi","Second name":"bla","Age":"4","Photo":"asfserwe","Draft":"sdfsdf"}] ```
 
## GoogleCloudSpeech.getAccessToken
Get OAuth access token

| Field      | Type       | Description
|------------|------------|----------
| apiKey     | credentials| Api key from Google Console
| apiSecret  | credentials| Api secret from Google Console
| code       | String     | Code provided by client
| redirectUrl| String     | Redirect URL (your app url)

## GoogleCloudSpeech.getSpeechRecognition
Get speech recognition

| Field          | Type       | Description
|----------------|------------|----------
| accessToken    | String     | Access token from getAccessToken method
| file           | File       | Audio file to recognition
| encoding       | Select     | Encoding type: LINEAR16, FLAC, MULAW, AMR, AMR_WB
| rate           | Number     | Sample rate in Hertz of the audio data sent. Valid values are: 8000-48000
| languageCode   | String     | The language of the supplied audio as a BCP-47 language tag. Example: 'en-GB'
| maxAlternatives| Number     | Maximum number of recognition hypotheses to be returned. Valid values are 0-30. A value of 0 or 1 will return a maximum of 1. If omitted, defaults to 1.
| profanityFilter| Boolean    | If set to true, the server will attempt to filter out profanities, replacing all but the initial character in each filtered word with asterisks, e.g. 'f***'. If set to false or omitted, profanities won't be filtered out.
| phrases        | List       | List of phrases. A means to provide context to assist the speech recognition.

## GoogleCloudSpeech.getSpeechRecognitionFromURL
Get speech recognition from URL

| Field          | Type       | Description
|----------------|------------|----------
| accessToken    | String     | Access token from getAccessToken method
| file           | String     | URL to Audio file to recognition
| encoding       | Select     | Encoding type: LINEAR16, FLAC, MULAW, AMR, AMR_WB
| rate           | Number     | Sample rate in Hertz of the audio data sent. Valid values are: 8000-48000
| languageCode   | String     | The language of the supplied audio as a BCP-47 language tag. Example: 'en-GB'
| maxAlternatives| Number     | Maximum number of recognition hypotheses to be returned. Valid values are 0-30. A value of 0 or 1 will return a maximum of 1. If omitted, defaults to 1.
| profanityFilter| Boolean    | If set to true, the server will attempt to filter out profanities, replacing all but the initial character in each filtered word with asterisks, e.g. 'f***'. If set to false or omitted, profanities won't be filtered out.
| phrases        | List       | List of phrases. A means to provide context to assist the speech recognition.

