import { render } from "@testing-library/react";
import LedFacet from "@/app/configurator/LedFacet";
import { useInfiniteQuery } from "@tanstack/react-query";
import { fetchCategoryArticles } from "@/lib/api";
import { useSelection } from "@/components/SelectionProvider";

jest.mock("@tanstack/react-query", () => ({
  useInfiniteQuery: jest.fn(),
}));

jest.mock("@/components/SelectionProvider", () => ({
  useSelection: jest.fn(),
}));

jest.mock("@/lib/api", () => ({
  fetchCategoryArticles: jest.fn(),
}));

describe("LedFacet", () => {
  it("filters LEDs by selected growbox", () => {
    (useSelection as jest.Mock).mockReturnValue({
      selections: { growbox: "g1", led: null },
      setSelection: jest.fn(),
    });
    (useInfiniteQuery as jest.Mock).mockReturnValue({
      data: { pages: [{ items: [] }] },
      fetchNextPage: jest.fn(),
      hasNextPage: false,
      isFetchingNextPage: false,
    });

    render(<LedFacet />);

    const options = (useInfiniteQuery as jest.Mock).mock.calls[0][0];
    expect(options.queryKey).toEqual(["ledArticles", "g1"]);
    options.queryFn({ pageParam: 1 });
    expect(fetchCategoryArticles).toHaveBeenCalledWith(
      "led",
      1,
      10,
      undefined,
      "g1",
    );
  });
});
