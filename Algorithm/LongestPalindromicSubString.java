public class LongestPalindromicSubString 
{
	/**
	 * 
	 * @param    strName  -String 需要计算的字符串 
	 * @return	 
	 */
	 public  static String longestPalindrome(String strName) 
	 {
		 //如果字符串为空 则返回为空 为空的标准是 strName == null 或则 strName.length() == 0
        if (strName.isEmpty()) 
        {  
            return null;  
        }
        //如果字符串只有一个字符  则返回该字符
        if (strName.length() == 1) 
        {  
            return strName;  
        }  
        String longest = strName.substring(0, 1); //先截取第一个字符串的第一个字符 为子串 初始为最长回文子串
        for (int i = 0; i < strName.length(); i++) 
        {   
            String tmp = helper(strName, i, i);  
            if (tmp.length() > longest.length()) 
            {  
                longest = tmp;  
            }  
            tmp = helper(strName, i, i + 1);  
            if (tmp.length() > longest.length()) 
            {  
                longest = tmp;  
            }  
        }  
        return longest;  
	 }
	
    public static String helper(String subStr, int begin, int end) 
    {  
        while (begin >= 0 && end <= subStr.length() - 1  && subStr.charAt(begin) == subStr.charAt(end)) 
        {  
            begin--;  
            end++;  
        }  
        String subS = subStr.substring(begin + 1, end);  
        return subS;  
    }  
  
    public static void main(String[] args) 
    {  
        String subStrLength=longestPalindrome("DFEGESGABCCBAADGEEE");//babcbabcbaccba
        System.out.println(subStrLength);
        System.out.println(subStrLength.length());
    }  
}
