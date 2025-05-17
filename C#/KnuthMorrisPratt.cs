using System;
using System.Linq;
using System.Collections.Generic;


// compile with: csc C#/KnuthMorrisPratt.cs
// then, run with: mono KnuthMorrisPratt.exe
class KnuthMorrisPratt
{
    public List<int> GetAllOccurrencesOfNeedleInHaystack(string needle, string haystack)
    {
        List<int> occurrences = new List<int>();
        int n = haystack.Length;
        int m = needle.Length;

        if (m == 0 || n == 0 || m > n)
            return occurrences;

        List<int> lps = GetLPSArray(needle);

        int i = 0;
        int j = 0;

        while (i < n)
        {
            if (j == m)
            {
                occurrences.Add(i - j);
                j = lps[j - 1];
            }
            else if (needle[j] == haystack[i])
            {
                i++;
                j++;
            }
            else
            {
                if (j != 0)
                    j = lps[j - 1];
                else
                    i++;
            }
        }

        return occurrences;
    }



    private List<int> GetLPSArray(string substring) 
    {
        List<int> lpsArray = new List<int>();
        lpsArray.Add(0);

        string startOfSubstring = "";
        string currSubstring = "";

        for(int i = 1; i < substring.Length; i++)
        {
            startOfSubstring += substring[i - 1];

            char currChar = substring[i];

            if (startOfSubstring.StartsWith(currSubstring + currChar))
            {
                lpsArray.Add(lpsArray.Last() + 1);
                currSubstring+= currChar;
            }
            else
            {
                lpsArray.Add(0);
                currSubstring = "";
            }
        }

        return lpsArray;
    }


    public static void Main(String[] args)
    {}
}