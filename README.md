Works great with reCAPTCHA v2 checkbox!

# reCAPTCHA for TYPO3 EXT:form

You can either choose to define your reCAPTCHA api Keys with typoscript,
or as environment variables.

## Typoscript setup 
Check out the typoscript constants file for it: `formrecaptcha/Configuration/TypoScript/constants.typoscript`

Make sure you add constants for 
`publicKey` and `privateKey`.<br /> 
You could also change `apiScript` and `verificationServer` but that is not necessary.

## Environment variables
I suggest to use DotEnv Conntector for this `composer req vlucas/phpdotenv`

Define your reCAPTCHA api keys as environment variables: \
`GOOGLE_RECAPTCHA_PUBLIC_KEY` and `GOOGLE_RECAPTCHA_PRIVATE_KEY` <br /> 
You could also set 
`GOOGLE_RECAPTCHA_API_SCRIPT`
and
`GOOGLE_RECAPTCHA_VERIFICATION_SERVER`
but that is not necessary.
 
