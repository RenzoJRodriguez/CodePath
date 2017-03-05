# Project 5 - Encryption

Time spent: **8** hours spent in total

## User Stories

The following **required** functionality is completed:

1\. Symmetric Encrypt/Decrypt
  * [X]  Required: Repair the symmetric encrypt and decrypt code

2\. Encrypted Message 1
  * [X]  Required: Decrypt the government message
  * [X]  Required: Encrypt a response and include in this README
  
    Response: pV7RGpCUhH2HVrVeq7T0mcpHMkjONeFUI782sK2BuztiEiluMYkNcfHR001AMdK5

3\. Generate Public-Private Keys
  * [X]  Required: Repair the key generator code
  * [X]  Required: Generate keys for "johnsteed" and add him to the Agent Directory

4\. Asymmetric Encrypt/Decrypt
  * [X]  Required: Repair the asymmetric encrypt and decrypt code

5\. Create/Verify Signature
  * [X]  Required: Repair the create and verify signature code
  
6\. Encrypted Message 2
  * [X]  Required: Decrypt the message
  * [X]  Required: Verify the message
  * [X]  Required: Include a response message in this README

    Message: P1r1WmeLSPQNBKEUDZCzVqk7S7SYS2I2JFuSy9Jh+iYDwxNtk4zI86VSQ5R+u77yj5ugkH/RYc4DKSyI+VvYm1dfvq3FqYHPwqSCMvXfqWahv6dhdtQgMHUOEk9+fQsZMQ5HKwL2lBqaKtlg48tY4AZAeBDyLjten3lLq5Kb0g1PT/BlYMU7CTiDGwfIK6LN93RR+1rMBw+X+SR7nQA39hE5AcsWePs40khZiFPrXen8lOarXJ9rfBPphj9l6OhIEgTyE5sOFKh70v7s3WmguCE+3hXqQmtgzZNeD2/ZpTApBf8gj0eUWrTk7JaP6EU25ZOB598/47HMRNo8N49RsQ==
    
    Signature: sL3rX+lVlA+/OUTbZpH1kokw+lSB0yPvx54wZzNvty1y2jyEM1wUJRQy1PWVILbuRVAJWXhgWFpiOpFk2go2pQrvMut6ZmRv+7zqN1271z/hoEK/PzYy7IhyU7EVdj61FufYyTjhaWE7qvi8rc74546uqJphiizpTce09qIIiLuqzz+q+QwSdN4SxtrjpCNEYodhCTQ7Km+O4p6wl5YICiWsVOoCXYpk0s7JCBOp5omObsEZc0wiDBy2UZV0T+mAXAqRjAcIE00O6QqW6Z9GCeraG1cmcctK9bfMNLOw6tfaa6Ytsok2EcYtxqLjj01DbE+deAtENOs/6MBD7/DXeQ==
    
    -----BEGIN PUBLIC KEY-----
    MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAyKNvqGv5ROD2h3HQLJTE
    U/MDNGrBMSEfIzftA4hUtsSGgngN1cpYuaQbt93rkzNbxvV11oN0laHrXMpB35Gw
    IZyd5pSLYJovWGeW6PAX4T2z313prdTktbiixr39exqMDuKnnBIq4qHmbHozgL6P
    kBHCY8DcnfR44v3cjb/G76SstVuoEsEoBDrMXgXzR/5y7iPJ+Lbia8UgT6sccGB3
    FrPeXgJtaXd0lW2CQFYMOFdZeNfF5Wz/vpig5OMshFQjhydXjJmYUqFrOiK2ZUYT
    sz0HV3pYEuDU8u0hjS/qaguenh6L7RjVQAKWXg2/suZ3JZf1cdxayDUz5fl+Bdjt
    xwIDAQAB
    -----END PUBLIC KEY-----

7\. Agent Messages
  * [X]  Required: Repair the dropbox code
  * [X]  Required: Repair the messages area
  * [X]  Required: Display encrypted messages for all agents
  * [X]  Required: Messages indicate whether the message signature is valid
  * [X]  Required: Your messages are automatically decrypted

8\. Identify the Double Agent
  * [X]  Required: Decrypt as many email messages as possible
  
    Email 1: The SQL injection we discussed is in place. Just search for an agent.
    Email 2: 
    Email 3: Today I was able to sneak several XSS vulnerabilities onto one of the encrypt/decrypt pages.
    Email 4: 
    Email 5: Let me know before you go inside. I'll create a distraction. - Austin
    Email 6: Let me know before you go inside. I'll create a distraction. - Natasha
  
  * [X]  Required: Identify the double agent
  
    Response: Natasha is the double agent. 
  
    Reason: The public key for "friend" worked on email #6 but not on email #5 (Dark Shadows' public key worked on that one). Dark Shadow forged email #5 to make it seem like Austin was working with them and not Natasha.

The following objectives are **optional**:

* Bonus Objective 1\.
  * [ ]  Track down the bugs in the code and fix them.

* Bonus Objective 2\.
  * [ ]  Write a report of your discoveries (longer than 300 characters).
  * [ ]  Compose a secure email for sending over an insecure network.
  * [ ]  Include the email with your encrypted report in this README.

* Bonus Objective 3\.
  * [ ]  Add a "Create/Verify Checksum" section to the Encryption Tools area.

* Advanced Objective 1\.
  * [ ]  Add support for other symmetric algorithms.

## Video Walkthrough

Here's a walkthrough of implemented user stories:

<img src='http://i.imgur.com/s8AREXZ.gif' title='Video Walkthrough' width='' alt='Video Walkthrough' />

GIF created with [LiceCap](http://www.cockos.com/licecap/).

## Notes

Describe any challenges encountered while building the app.

## License

    Copyright 2017 Renzo Rodriguez

    Licensed under the Apache License, Version 2.0 (the "License");
    you may not use this file except in compliance with the License.
    You may obtain a copy of the License at

        http://www.apache.org/licenses/LICENSE-2.0

    Unless required by applicable law or agreed to in writing, software
    distributed under the License is distributed on an "AS IS" BASIS,
    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
    See the License for the specific language governing permissions and
    limitations under the License.
